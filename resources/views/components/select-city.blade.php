<select id="citySelect" name="city_id">
    <option value="">City</option>
    @foreach ($cities as $city)
        <option value="{{ $city->id }}" data-parent="{{ $city->state_id }}">
            {{ $city->name }}
        </option>
    @endforeach
</select>
