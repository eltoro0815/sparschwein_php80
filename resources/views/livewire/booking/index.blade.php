<div>
    <div class="card-controls sm:flex">
        <div class="w-full sm:w-1/2">
            Pro Seite:
            <select wire:model="perPage" class="form-select w-full sm:w-1/6">
                @foreach($paginationOptions as $value)
                <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

            @can('booking_delete')
            <button class="btn btn-rose ml-3 disabled:opacity-50 disabled:cursor-not-allowed" type="button" wire:click="confirm('deleteSelected')" wire:loading.attr="disabled" {{ $this->selectedCount ? '' : 'disabled' }}>
                {{ __('Ausgewählte löschen') }}
            </button>
            @endcan

            @if(file_exists(app_path('Http/Livewire/ExcelExport.php')))
            <livewire:excel-export model="Booking" format="csv" />
            <livewire:excel-export model="Booking" format="xlsx" />
            <livewire:excel-export model="Booking" format="pdf" />
            @endif




        </div>
        <div class="w-full sm:w-1/2 sm:text-right">
            Search:
            <input type="text" wire:model.debounce.300ms="search" class="w-full sm:w-1/3 inline-block" />
        </div>
    </div>
    <div wire:loading.delay>
        Loading...
    </div>

    <div class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-index w-full">
                <thead>
                    <tr>
                        <th class="w-9">
                        </th>
                        <th class="w-28">
                            {{ trans('cruds.booking.fields.id') }}
                            @include('components.table.sort', ['field' => 'id'])
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.amount') }}
                            @include('components.table.sort', ['field' => 'amount'])
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.date') }}
                            @include('components.table.sort', ['field' => 'date'])
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td>
                            <input type="checkbox" value="{{ $booking->id }}" wire:model="selected">
                        </td>
                        <td>
                            {{ $booking->id }}
                        </td>
                        <td>
                            {{ $booking->amount }} EUR
                        </td>
                        <td>
                            {{ $booking->date }}
                        </td>
                        <td>
                            <div class="flex justify-end">
                                @can('booking_show')
                                <a class="btn btn-sm btn-info mr-2" href="{{ route('admin.bookings.show', $booking) }}">
                                    {{ trans('global.view') }}
                                </a>
                                @endcan
                                @can('booking_edit')
                                <a class="btn btn-sm btn-success mr-2" href="{{ route('admin.bookings.edit', $booking) }}">
                                    {{ trans('global.edit') }}
                                </a>
                                @endcan
                                @can('booking_delete')
                                <button class="btn btn-sm btn-rose mr-2" type="button" wire:click="confirm('delete', {{ $booking->id }})" wire:loading.attr="disabled">
                                    {{ trans('global.delete') }}
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">No entries found.</td>
                    </tr>
                    @endforelse

                    <tr>
                        <td>

                        </td>
                        <td>
                            Kontostand
                        </td>
                        <td>
                            {{number_format($bookings->sum('amount'), 2, ',' , '.') }} EUR
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div class="card-body">
        <div class="pt-3">
            @if($this->selectedCount)
            <p class="text-sm leading-5">
                <span class="font-medium">
                    {{ $this->selectedCount }}
                </span>
                {{ __('Entries selected') }}
            </p>
            @endif
            {{ $bookings->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    Livewire.on('confirm', e => {
        if (!confirm("{{ trans('global.areYouSure') }}")) {
            return
        }
        @this[e.callback](...e.argv)
    })
</script>
@endpush
