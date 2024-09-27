<!-- resources/views/tweets/search.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('User検索') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          <!-- 検索フォーム -->
          <form action="{{ route('profile.search') }}" method="GET" class="mb-6">
            <div class="flex items-center">
              <input type="text" name="keyword" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Search for tweets..." value="{{ request('keyword') }}">
              <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                Search
              </button>
            </div>
          </form>

          <!-- 検索結果表示 -->
          @if ($user->count())

          <!-- ページネーション -->
          <div class="mb-4">
            {{ $user->appends(request()->input())->links() }}
          </div>

          @foreach ($user as $oneUser)
          <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <p class="text-gray-800 dark:text-gray-300">{{ $oneUser->name }}</p>
            <a href="{{ route('profile.show', $oneUser) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>

            <!-- フォローとフォロー解除 -->
            @if ($oneUser->id !== auth()->id())
            <div class="text-gray-900 dark:text-gray-100">
                @if ($oneUser->followers->contains(auth()->id()))
                <form action="{{ route('follow.destroy', $oneUser) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">unFollow</button>
                </form>
                @else
                <form action="{{ route('follow.store', $oneUser) }}" method="POST">
                @csrf
                <button type="submit" class="text-blue-500 hover:text-blue-700">follow</button>
                </form>
                @endif
            </div>
            @endif
            <!-- 🔽 フォローフォロワー数 -->
            <p>following: {{$oneUser->follows->count()}}</p>
            <p>followers: {{$oneUser->followers->count()}}</p>
          </div>
          @endforeach

          <!-- ページネーション -->
          <div class="mb-4">
            {{ $user->appends(request()->input())->links() }}
          </div>

          @else
          <p>No users found.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

