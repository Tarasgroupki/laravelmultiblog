@if(Request::route()->getName() == 'blog_view' || Request::route()->getName() == 'cat_blog' || Request::route()->getName() == 'users_edit')
@if(Request::route()->getName() == 'users_edit')
@foreach ($langs as $lang)
<a href="{{ route(Request::route()->getName(),['locale' => $lang->locale,'user' => Route::current()->parameters()['user']])}}">{{ $lang->lang_symbols }}</a>
@endforeach
@else
@foreach ($langs as $lang)
<a href="{{ route(Request::route()->getName(),['locale' => $lang->locale,'id' => Route::current()->parameters()['id'],'slug' => Route::current()->parameters()['slug']])}}">{{ $lang->lang_symbols }}</a>
@endforeach
@endif
@else
@foreach ($langs as $lang)
<a href="{{ route(Request::route()->getName(),['locale' => $lang->locale])}}">{{ $lang->lang_symbols }}</a>
@endforeach
@endif