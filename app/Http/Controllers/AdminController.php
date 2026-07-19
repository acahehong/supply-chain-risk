<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Port;
use App\Models\Country;
use App\Models\Article;
use App\Models\PositiveWord;
use App\Models\NegativeWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Shipment;
use App\Models\NewsCache;

class AdminController extends Controller
{
    public function editUser(User $user)
{
    return view('admin.edit-user', compact('user'));
}

public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return redirect()
        ->route('admin.users')
        ->with('success', 'User berhasil diperbarui.');
}

    public function createUser()
{
    return view('admin.create-user');
}

public function storeUser(Request $request)
{
    $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|confirmed|min:8',
]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect()
        ->route('admin.users')
        ->with('success', 'User berhasil ditambahkan.');
}

    public function dashboard()
{
    return view('admin.dashboard', [

        'totalCountries' => Country::count(),

        'totalPorts' => Port::count(),

        'totalShipments' => Shipment::count(),

        'delayedShipments' => Shipment::where('status','Delayed')->count(),

        'possibleDelay' => Shipment::where('status','Possible Delay')->count(),

        'onSchedule' => Shipment::where('status','On Schedule')->count(),

        'delivered' => Shipment::where('status','Delivered')->count(),

        'totalNews' => NewsCache::count(),

        'totalUsers' => User::count(),

        'avgProgress' => round(Shipment::avg('progress'),0),

    ]);
}

    public function users()
    {
        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }

    public function ports(Request $request)
{
    $search = $request->search;

    $ports = Port::with('country')
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->paginate(20);

    return view('admin.ports', compact('ports', 'search'));
}

 public function articles(Request $request)
{
    $query = Article::query();

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $articles = $query->latest()->paginate(10);

    return view('admin.articles', [
        'articles'  => $articles,
        'total'     => Article::count(),
        'positive'  => Article::where('sentiment', 'Positive')->count(),
        'neutral'   => Article::where('sentiment', 'Neutral')->count(),
        'negative'  => Article::where('sentiment', 'Negative')->count(),
    ]);
}
    public function createArticle()
{
    return view('admin.create-article');
}

public function storeArticle(Request $request)
{
    $request->validate([
        'title' => 'required',
        'category' => 'required',
        'content' => 'required',
    ]);

    $text = strtolower($request->title . ' ' . $request->content);

    $positiveWords = PositiveWord::pluck('word')->toArray();
    $negativeWords = NegativeWord::pluck('word')->toArray();

    $positiveCount = 0;
    $negativeCount = 0;

    // Hitung kata positif
    foreach ($positiveWords as $word) {
        $positiveCount += substr_count($text, strtolower($word));
    }

    // Hitung kata negatif
    foreach ($negativeWords as $word) {
        $negativeCount += substr_count($text, strtolower($word));
    }

    // Tentukan sentiment
    if ($negativeCount >= $positiveCount + 2) {
        $sentiment = 'Negative';
    } elseif ($positiveCount >= $negativeCount + 2) {
        $sentiment = 'Positive';
    } else {
        $sentiment = 'Neutral';
    }

    // Hitung Risk Score
    $total = $positiveCount + $negativeCount;

    if ($total > 0) {
        $riskScore = round(($negativeCount / $total) * 100);
    } else {
        $riskScore = 0;
    }

    Article::create([
        'title' => $request->title,
        'category' => $request->category,
        'content' => $request->content,
        'sentiment' => $sentiment,
        'risk_score' => $riskScore,
    ]);

    return redirect()
        ->route('admin.articles')
        ->with('success', 'Article added successfully.');
}

    public function editArticle(Article $article)
{
    return view('admin.edit-article', compact('article'));
}

public function updateArticle(Request $request, Article $article)
{
    $request->validate([
        'title'=>'required',
        'category'=>'required',
        'content'=>'required'
    ]);

    $article->update([
        'title'=>$request->title,
        'category'=>$request->category,
        'content'=>$request->content,
    ]);

    return redirect()
        ->route('admin.articles')
        ->with('success','Artikel berhasil diperbarui.');
}

    public function destroyArticle(Article $article)
    {
        $article->delete();

        return back()->with(
            'success',
            'Artikel berhasil dihapus.'
        );
}

    public function destroyUser(User $user)
    {
        $user->delete();

        return back()->with('success','User berhasil dihapus.');
    }
}