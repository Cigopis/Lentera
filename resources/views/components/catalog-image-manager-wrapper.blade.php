
@php
    $record = is_callable($getRecord) ? $getRecord() : $getRecord;
@endphp

@if($record?->id)
    @livewire('catalog-image-manager', ['catalogId' => $record->id], key('img-mgr-'.$record->id))
@endif