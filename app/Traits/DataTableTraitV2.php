<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\EloquentDataTable;

trait DataTableTraitV2
{
    // buttons flags
    private static $show_edit_btn = false;
    private static $show_view_btn = false;
    private static $show_delete_btn = false;

    /** @var array */
    private static $defaultColumns = [
        [
            'data' => 'action',
            'name' => 'action',
            'orderable' => false,
            'searchable' => false,
            'className' => 'text-center'
        ]
    ];


    abstract protected static function list(Request $request): Builder;

    /**
     * @return array
     */
    public static function getSearchableFields(): array
    {
        return self::$searchable ?? [];
    }

    /**
     * @return array
     */
    public static function getSearchableRelatedFields(): array
    {
        return self::$searchableRelated ?? [];
    }

    /**
     * @return Builder
     */
    public static function search($sorts = [])
    {
        $search = request('search.value');
        $searchable = self::getSearchableFields();
        $related = self::getSearchableRelatedFields();

        $model = self::class;
        $table = (new $model())->table;

        return self::query()
                ->with(array_unique(array_keys($related)))
                ->when(!empty($search), function ($query) use ($searchable, $related, $search, $table) {
                    foreach ($searchable as $i => $field) {
                        $raw = false;
                        if (! is_string($field)) {
                            $raw = true;
                        }

                        if ($raw) {
                            // let's loop through
                            foreach ($field as $ir => $raw_field) {
                                if ($ir === 0
                                    && $i === 0
                                ) {
                                    $query->whereRaw($raw_field . ' LIKE ?', '%' . $search . '%');
                                } else {
                                    $query->orWhereRaw($raw_field . ' LIKE ?', '%' . $search . '%');
                                }
                            }
                        } else {
                            if ($i === 0) {
                                $query->where($table . '.' . $field, 'LIKE', '%' . $search . '%');
                            } else {
                                $query->orWhere($table . '.' . $field, 'LIKE', '%' . $search . '%');
                            }
                        }
                    }

                    foreach ($related as $relatedTable => $field) {
                        $i = 0;

                        // check if raw
                        $raw = false;
                        if (! is_string($field)) {
                            $raw = true;
                        }

                        if (sizeof($searchable)) {
                            $query->orWhereHas($relatedTable, function ($q) use ($raw, $field, $search, $searchable) {
                                if ($raw) {
                                    return self::getRelatedColumnRaw($q, $field, $search);
                                } else {
                                    return self::getRelatedCond($q, $searchable, $field, $search);
                                }
                            });
                        } elseif ($i === 0) {
                            $query->whereHas($relatedTable, function ($q) use ($raw, $field, $search, $searchable) {
                                if ($raw) {
                                    return self::getRelatedColumnRaw($q, $field, $search);
                                } else {
                                    return self::getRelatedCond($q, $searchable, $field, $search);
                                }
                            });
                        } else {
                            $query->whereHas($relatedTable, function ($q) use ($raw, $field, $search, $searchable) {
                                if ($raw) {
                                    return self::getRelatedColumnRaw($q, $field, $search);
                                } else {
                                    return self::getRelatedCond($q, $searchable, $field, $search);
                                }
                            });
                        }

                        $i++;
                    }

                    return $query;
                })
                // validate request for order
                ->when(request()->has('order'),
                    function ($query) {

                        // get sort
                        $sortOrder = self::getSortOrder();

                        // validate
                        if (!empty($sortOrder)
                            && is_null($sortOrder['relation'])
                        ) {

                            // order by column
                            $query->orderBy($sortOrder['column'], $sortOrder['dir']);
                        }
                    },
                    function ($query) use ($sorts) {

                        // check sort
                        if (!empty($sorts)) {

                            // loop through the sorts
                            foreach ($sorts as $column => $dir) {
                                $query->orderBy($column, $dir);
                            }
                        }
                    }
                );
    }


    protected static function getRelatedColumnRaw($query, $field, $search)
    {
        foreach ($field as $key => $raw_field) {
            if ($key == 0) {
                $query->whereRaw($raw_field . ' LIKE ?', '%' . $search . '%');
            } else {
                $query->orWhereRaw($raw_field . ' LIKE ?', '%' . $search . '%');
            }
        }

        return $query;
    }


    protected static function getRelatedCond($q, $searchable, $field, $search)
    {
        if (! is_array($field)) { 
            return $q->where($field, 'LIKE', '%' . $search . '%');
        }


        $i = 0;
        foreach ($field as $idx => $col) {
            if (is_string($idx)) {
                if (sizeof($searchable)) {
                    $q->orWhereHas($idx, fn ($q1) => self::getRelatedCond($q1, $searchable, $col, $search));
                } elseif ($i === 0) {
                    $q->whereHas($idx, fn ($q1) => self::getRelatedCond($q1, $searchable, $col, $search));
                } else {
                    $q->whereHas($idx, fn ($q1) => self::getRelatedCond($q1, $searchable, $col, $search));
                }
            } else if ($i === 0) {
                $q->where($col, 'LIKE', '%' . $search . '%');
            } else {
                $q->orWhere($col, 'LIKE', '%' . $search . '%');
            }
            $i++;
        }

        return $q;
    }


    /**
     * @return array
     */
    public static function getSortOrder(): array
    {
        // prepare response
        $sortData = [
            'column' => null,
            'relation' => null,
            'dir' => 'asc'
        ];

        // check if we have request
        if (request()->has('order')) {

            // get order
            $order = request('order')[0];

            // let's get the index of column being sort
            $index = (int) $order['column'];
            // let's get the direction
            $dir = $order['dir'] ?? 'asc';

            // get columns
            $columns = self::getColumns(request()->has('source') ? request()->get('source') : '');

            // check if column is available
            if (array_key_exists($index, $columns)) {

                // get data
                $columnData = $columns[$index]['data'];
                $relation = null;

                // check if column is relationship
                if (array_key_exists('defaultContent', $columns[$index])
                    && strpos($columnData, '.') !== false
                ) {

                    // extract data into column and relation
                    $relatedColumnData = explode('.', $columnData);

                    // amend related and column
                    $relation = $relatedColumnData[0];
                    $columnData = $relatedColumnData[1];

                    // check if we have more than 2
                    if (count($relatedColumnData) > 2) {

                        // get last column data
                        $columnData = end($relatedColumnData);

                        // remove last column data and get the relations
                        array_pop($relatedColumnData);
                        $relation = implode('.', $relatedColumnData);
                    }
                }

                $sortData['column'] = $columnData;
                $sortData['relation'] = $relation;
                $sortData['dir'] = $dir;
            }
        }

        return $sortData;
    }


    /**
     * @return array
     */
    public static function getDataTableColumns(string $type = ''): array
    {
        $columns = self::$dataTableColumns ?? [];

        if (! property_exists(self::class, 'includeDefaultColumns') || self::$includeDefaultColumns) {
            $columns = array_merge($columns, self::$defaultColumns);
        }

        return $columns;
    }


    /**
     * @return int
     */
    protected static function getRecordsTotal(Request $request): int
    {
        if ($count = self::getListCount($request)) {
            return $count;
        }

        return self::when(method_exists(new (self::class), 'scopeListConditions'), fn (Builder $query) => $query->listConditions($request))
                ->count();
    }

    /**
     * @param  mixed  $search
     * @return int
     */
    protected static function getRecordsFiltered(Request $request): int
    {
        if ($count = self::getSearchListCount($request)) {
            return $count;
        }

        return self::search()
                ->when(method_exists(new (self::class), 'scopeListConditions'), fn (Builder $query) => $query->listConditions($request))
                ->when(method_exists(new (self::class), 'scopeListFilterConditions'), fn (Builder $query) => $query->listFilterConditions($request))
                ->count();
    }


    protected static function getListCount(Request $request): int
    {
        return 0;
    }


    protected static function getSearchListCount(Request $request): int
    {
        return 0;
    }

    /**
     * Checks buttons if we allow them to be seen by user
     *
     * @param string $table
     * @return void
     */
    private static function checkButtons(string $table)
    {
        // permission
        $table = self::$permission_prefix ?? $table;

        // show edit button
        self::$show_edit_btn = ! Gate::denies($table . '_edit') ? true : false;
        self::$show_view_btn = ! Gate::denies($table . '_show') ? true : false;
        self::$show_delete_btn = ! Gate::denies($table . '_delete') ? true : false;
    }
    
    /**
     * @param Model $data
     * @return string
     */
    public static function renderButtons(Model $data): string
    {
        // get table
        $model = self::class;
        $table = (new $model())->table;

        $deletable = self::$deletable ?? true;

        // prepare button holder
        $buttons = '';
        self::checkButtons($table);

        // if show edit btn is true, hide view button
        if (self::$show_edit_btn) {
            self::$show_view_btn = false;
        }

        // if deletable
        if (! $deletable) {
            self::$show_delete_btn = false;
        }

        $table = self::$button_ctlr ?? $table;

        // if show view button
        if (self::$show_view_btn) {
            $buttons .= '<a href="' . route($table . '.show', $data->id) . '" class="mr-3 show bs-tooltip" title="' . label('show') . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
        }

        // if show edit button
        if (self::$show_edit_btn) {
            $buttons .= '<a href="' . route($table . '.edit', $data->id) . '" class="mr-3 edit bs-tooltip" title="' . label('edit') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        }

        if (self::$show_delete_btn) {
            $buttons .= '<a class="delete deleteIcon bs-tooltip" href="#" title="' . label('delete') . '" data-url="' . route($table . '.destroy', $data->id) . '" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        }

        return $buttons;
    }

    /**
     * @param  Builder  $data
     * @return EloquentDataTable
     */
    public static function dataTablesOf(Request $request, Builder $data = null): EloquentDataTable
    {
        if (! $data) {
            $data = self::list($request);
        }

        $dataTable = DataTables::of($data);
        
        $recordsTotal = self::getRecordsTotal($request);
        $recordsFiltered = self::getRecordsFiltered($request);

        $dataTable->with(compact('recordsTotal', 'recordsFiltered'));

        $dataTable
            //->setOffset(request('start'))
            ->addIndexColumn();

        if (! property_exists(self::class, 'includeDefaultColumns') || self::$includeDefaultColumns) {
            $dataTable->addColumn('action', function ($row) use ($data) {
                    return $row->renderButtons($row);
                })
                ->rawColumns(['action']);
        }


        // for raw columns or for columns with special formatting
        $dataTable = self::editCustom($dataTable);

        
        // format columns
        $columns_for_edit = collect(self::getColumns($request->input('source') ?? ''))->whereNotNull('type');
        $columns_for_edit->each(function ($column, int $key) use($dataTable) {
            $column_type = $column['type'];
            $column_name = $column['name'];

            if ($column_type === 'currency') {
                $dataTable->editColumn($column_name, fn ($row) => currency($row[$column_name]));
            } else if ($column_type === 'percentage') {
                $dataTable->editColumn($column_name, 
                    fn ($row) => 
                        !empty($row[$column_name]) 
                            ? ($row[$column_name] .'%') 
                            : $row[$column_name]
                    );
            } else if ($column_type === 'date') {
                $dataTable->editColumn($column_name, 
                    fn ($row) =>
                        getFormattedDate(self::getRowData($row, $column_name))
                    );
            } else if ($column_type === 'datetime') {
                $dataTable->editColumn($column_name, 
                    fn ($row) =>
                        getFormattedDateTime(self::getRowData($row, $column_name))
                    );
            }
        });

        return $dataTable;
    }


    private static function getRowData($row, string $column_name)
    {
        $data = $row[$column_name] ?? '';

        if (strpos($column_name,'.') !== false) {
            $coldata = explode('.', $column_name);
            if (count($coldata) === 2) {
                $data = ($row[$coldata[0]] ?? false) 
                        ? $row[$coldata[0]][$coldata[1]] 
                        : '';

            } else if (count($coldata) === 3) {
                $data = ($row[$coldata[0]] ?? false) 
                        ? (($row[$coldata[0]][$coldata[1]] ?? false) 
                            ? $row[$coldata[0]][$coldata[1]][$coldata[2]]
                            : '')
                        : '';
            }
        } 

        return $data;
    }


    public static function getColumns(string $source = ''): array
    {
        return self::getDataTableColumns($source);
    }


    protected static function editCustom($data_table)
    {
        return $data_table;
    }


    public function scopePage(Builder $query, Request $request): void
    {
        $query->skip($request->get('start', 0))
                ->take($request->get('length', config('admin.table_page_len')));
    }
}