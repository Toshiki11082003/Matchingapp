<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // この行を `true` に変更して、このリクエストを承認します。
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255', // タイトルは必須で最大255文字
            'body' => 'required', // 本文は必須
            'university_name' => 'required|max:255', // 大学名は必須で最大255文字
            'circle_name' => 'required|max:255', // サークル名は必須で最大255文字
            'circle_type' => 'nullable|max:255', // サークルの種類は必須ではないが最大255文字
            'event_date' => 'nullable|date', // イベント開催日時は日付形式で必須ではない
            'event_location' => 'nullable|max:255', // イベント開催場所は必須ではないが最大255文字
            'deadline' => 'nullable|date', // 締め切りは日付形式で必須ではない
            'free_text' => 'nullable|max:1000', // 追加情報は必須ではなく最大1000文字
            'cost' => 'nullable|numeric' // 費用は数値で、必須ではない
        ];
    }
}
