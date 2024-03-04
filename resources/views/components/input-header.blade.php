@props([
    'wmodel' => null,
    'placeholder' => null,
    'searchsInputs' => []
])

<td class="p-0">
    <div class="m-0 p-0 input-group">
        <input type="text" name="{{ $wmodel }}" class="form-control form-control-sm" placeholder="{{ $placeholder }}" wire:model.debounce.500ms='{{ "searchsInputs.$wmodel" }}'>
        @if (isset($searchsInputs[$wmodel]) && strlen($searchsInputs[$wmodel]) > 0)
            <div class="input-group-append">
                <button wire:click="$set('searchsInputs.{{ $wmodel }}', null)" class="btn btn-sm btn-outline-danger" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>
</td>
