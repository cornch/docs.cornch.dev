<?php

namespace App\Http\Requests;

use App\Documentation\Loader as DocLoader;
use App\Documentation\Models\PathInfo;
use Illuminate\Foundation\Http\FormRequest;

class DocumentationBasedRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function getDocPathInfo(): PathInfo
    {
        return new PathInfo(
            doc: $this->route('doc'),
            locale: $this->route('locale'),
            version: $this->route('version'),
            page: $this->route('page')
        );
    }

    public function getDocLoader(): DocLoader
    {
        return app()->make(DocLoader::class, ['pathInfo' => $this->getDocPathInfo()]);
    }
}
