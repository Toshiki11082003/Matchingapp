</php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // カテゴリーモデルを使用する場合

class CategoryController extends Controller
{
    /**
     * カテゴリー一覧を表示します。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // カテゴリーデータを取得します。
        $categories = Category::all();

        // categories/index.blade.php ビューを表示し、カテゴリーデータを渡します。
        return view('categories.index', ['categories' => $categories]);
    }

    // 他のアクション（カテゴリーの作成、編集、削除など）をここに追加します。
}

