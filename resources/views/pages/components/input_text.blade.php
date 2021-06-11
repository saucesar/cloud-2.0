<label for="{{ $name }}">{{ $label }}</label>
<input type="{{ $type ?? 'text' }}" class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" value="{{ $value ?? old($name) }}"
       {{ !isset($required) ? : 'required' }} placeholder="{{ $placeholder ?? '' }}" title="{{ $title ?? '' }}">
@error($name)
<small class="text-danger">{{ $message }}</small>
@enderror