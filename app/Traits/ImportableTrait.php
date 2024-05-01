<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait ImportableTrait
{
    /**
     * @return string
     */
    public function getCsvTemplateDownloadUrl(): string
    {
        return route('imports.csv-template', ['model' => $this->getTable()]);
    }

    /**
     * @return string
     */
    public function getCsvImportUrl(): string
    {
        return route('imports.import', ['importer' => $this->getImporter()]);
    }

    /**
     * @return array
     */
    public function getFillable(): array
    {
        $fillable = array_flip($this->fillable);
        $fillable = Arr::except($fillable, $this->getExcludeFields());
        return array_flip($fillable);
    }

    /**
     * @return array
     */
    public function getExcludeFields(): array
    {
        return ['id', 'created_at', 'updated_at', 'deleted_at', 'product_group_id', 'product_subgroup_id', 'product_category_id'];
    }
}