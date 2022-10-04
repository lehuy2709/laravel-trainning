@if ($subjectDetail)
    @php
        $i = 0;
    @endphp
    @foreach ($subjectDetail->subjects as $subject)
        @php
            $i++;
        @endphp
        <tr>
            <th scope="row">{{ $i }}</th>
            <td>{{ $subject->name }}</td>
            @if ($subject->pivot->point)
                {
                <td><input type="number" name="point" id="point" class="form-control"
                        value="{{ $subject->pivot->point }}"></td>
                }
            @else
                <td><input type="number" name="point" id="point" value="" class="form-control"></td>
            @endif
        </tr>
    @endforeach
@endif
<td><button type="submit" class="btn btn-primary">Update</button></td>
