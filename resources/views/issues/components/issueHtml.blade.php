@if($issue->header_text)
    <p>{{ $issue->header_text }}</p>
@endif
<ul>
    @foreach($issue->links as $link)
        <li>
            <a href="{{ $link->url }}">{{ $link->title }}</a>
        </li>
    @endforeach
</ul>
@if($issue->footer_text)
    <p>{{ $issue->footer_text }}</p>
@endif