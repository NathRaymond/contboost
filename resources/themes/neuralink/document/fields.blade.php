@if (!empty($usecase->fields))
    @foreach ($usecase->fields as $field)
        <div class="col-md-12 mb-3">
            <label for="{{ $field->id }}" class="form-label">{{ $field->label }}</label>
            @if ($field->type == 'textfield')
                <input type="text" class="form-control" placeholder="{{ $field->placeholder ?? '' }}"
                    name="values[{{ $field->id }}]" @if (isset($field->required) && $field->required == 1) required @endif />
            @else
                <textarea class="form-control" placeholder="{{ $field->placeholder ?? '' }}" name="values[{{ $field->id }}]"
                    @if (isset($field->required) && $field->required == 1) required @endif></textarea>
            @endif
        </div>
    @endforeach
@endif
