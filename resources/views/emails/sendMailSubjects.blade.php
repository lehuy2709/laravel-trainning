<h1>Notice Register Subject</h1>
<div>
    Number of subjects you have not studied:
    <ul>
        @foreach ($subjectsNotYet as $item)
        <li>{{$item->id}}</li>
        @endforeach
    </ul>
</div>
<h2>Please register</h2>
