<form wire:submit.prevent="submit" class="pt-3">

    <div class="form-group {{ $errors->has('booking.amount') ? 'invalid' : '' }}">
        <label class="form-label required" for="amount">{{ trans('cruds.booking.fields.amount') }}</label>
        <input class="form-control" type="number" name="amount" id="amount" required wire:model.defer="booking.amount" step="0.01">
        <div class="validation-message">
            {{ $errors->first('booking.amount') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.booking.fields.amount_helper') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('booking.date') ? 'invalid' : '' }}">
        <label class="form-label required" for="date">{{ trans('cruds.booking.fields.date') }}</label>
        <x-date-picker class="form-control" required wire:model="booking.date" id="date" name="date" />
        <div class="validation-message">
            {{ $errors->first('booking.date') }}
        </div>
        <div class="help-block">
            {{ trans('cruds.booking.fields.date_helper') }}
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-indigo mr-2" type="submit">
            {{ trans('global.save') }}
        </button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
            {{ trans('global.cancel') }}
        </a>
    </div>
</form>