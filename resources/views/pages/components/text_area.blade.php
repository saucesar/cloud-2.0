<label for="{{ $name }}">{{ $label }}</label>
<textarea class="form-control" placeholder="{{ $placeholder ?? '' }}" required="{{ isset($required) ? 'true' : 'false' }}"
          rows="5" name="{{ $name }}" cols="50">{{ $value ?? old($name) }}</textarea>
@error($name)
<small class="text-danger">{{ $message }}</small>
@enderror