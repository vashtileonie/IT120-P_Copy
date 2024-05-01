<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ErrorTrait
{
    private $errors = [];

    /**
     * Identifies if to return error as array
     *
     * @var boolean
     */
    private $error_as_array = false;

    /**
     * Returns true/false depending if there's error or none
     */
    public function hasError()
    {
        return count($this->errors) > 0;
    }

    /**
     * Prepares to set Field error
     *
     * @param string $field
     * @param array|string $errors
     * @return void
     */
    protected function setFieldError(string $field, array|string $errors): void
    {
        $this->setError([
            $field => (!is_array($errors) ? [$errors] : $errors)
        ]);
    }

    /**
     * Sets error for response
     *
     * @param string|array
     * @return void
     */
    protected function setError(string|array $error): void
    {
        // if error is array
        if (is_array($error)) {
            $this->errors = array_merge($this->errors, $error);
        } else {
            $this->errors[] = $error;
        }
    }

    /**
     * Returns the errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Flags to return errors as array
     *
     * @return void
     */
    public function errorAsArray()
    {
        $this->error_as_array = true;
    }

    /**
     * Returns error response
     *
     * @param string $message
     * @param string $status_code
     * @return Response
     */
    protected function errorResponse(string $message, $status_code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        $data = [
            'status'    => 'error',
            'message'   => $message,
        ];

        // check errors
        if (!empty($this->errors)) {
            $data['errors'] = $this->errors;
        }

        // if as array
        if ($this->error_as_array) {
            return $data;
        }

        $error_response = response()
                            ->json($data, $status_code);

        return $error_response;
    }
}