<div id="saveActions" class="form-group">

    <input type="hidden" name="save_action" value="{{ $saveAction['active']['value'] }}">
    <button type="submit" class="btn btn-success">
        <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
        <span data-value="{{ $saveAction['active']['value'] }}">{{ $saveAction['active']['label'] }}</span>
    </button>

    <a href="javascript:void(0);window.opener.app.$refs['calendar'].closeModal();" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
</div>
