<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait StorageTrait
{
    private $storage_driver = 's3';
    private $storage_path = '';

    /**
     * Set Storage path
     *
     * @param string $folder
     * @param boolean $images
     * @return void
     */
    public function setStoragePath($folder, bool $images = true)
    {
        // prepare images path
        $images_path = $images ? '/images' : '';

        // set path
        $this->storage_path = env('AWS_BUCKET_PATH') . $images_path . '/' . $folder;
    }

    /**
     * Returns Image
     *
     * @param string $image
     * @param int $minutes
     * @return string
     */
    public function getImage($image, $minutes = 10)
    {
        // check if we have set limit
        if (! empty(config('webtool.aws.timeout_temp_url'))) {
            $minutes = config('webtool.aws.timeout_temp_url');
        }

        // set lifetime
        $lifetime = now()->addMinutes($minutes);

        // file path
        $file_path = $this->storage_path . '/' .basename($image);

        // check if image exists
        if ($this->exists($file_path)) {

            // return image
            return Storage::disk($this->storage_driver)
                            ->temporaryUrl($file_path, $lifetime);
        }

        return null;
    }

    /**
     * Store Image
     *
     * @param object $request
     * @param string $input_name
     * @param array $data
     * @param string $image
     * @return void
     */
    private function storeImage($request, ?string $input_name = null, array &$data, $image = null)
    {
        // check if its an upload
        if (! is_null($input_name)
            && $request->hasFile($input_name)
        ) {

            // prepare file
            $file = $request->file($input_name);
        } else {

            // prepare file
            $file = $request;
        }

        // check if $file is an object
        if ($file instanceof UploadedFile) {

            // file name and path
            $file_name = $file->hashName();
            $file_path = $this->storage_path . '/' . $file_name;

            // prepare path
            Storage::disk($this->storage_driver)
                ->put($file_path, $file);

            // amend to data
            $data[$input_name ?? $file_name] = Storage::disk($this->storage_driver)
                                                ->url($file_path);
        }


        // prepare file path
        $old_file_path = $this->storage_path . '/' . basename($image);

        // if there's existing, replace/delete it
        if (!is_null($image)
            && $this->exists($old_file_path)
        ) {

            // delete remote file
            Storage::disk($this->storage_driver)
                    ->delete($old_file_path);
        }
    }

    /**
     * Checks if image exists
     *
     * @param string $file_path
     * @return bool
     */
    private function exists($file_path)
    {
        return Storage::disk($this->storage_driver)
                        ->exists($file_path);
    }
}