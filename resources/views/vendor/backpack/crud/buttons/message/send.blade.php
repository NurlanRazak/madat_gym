<a  href="javascript:void(0)"
    data-id="{{ $entry->getKey() }}"
    onclick="bulkSendMessage(this)"
    class="btn btn-xs btn-success message-send"
    style="font-weight: 400; display: {{ $entry->isSent() ? 'none' : 'inline-block' }};"
>
    <i class="fa fa-paper-plane"></i> Разослать
</a>

<a  href="javascript:void(0)"
    data-id="{{ $entry->getKey() }}"
    onclick="bulkCancelMessage(this)"
    class="btn btn-xs btn-danger message-cancel"
    style="font-weight: 400; display: {{ !$entry->isSent() ? 'none' : 'inline-block' }}"
>
    <i class="fa fa-ban"></i> Отменить
</a>

<script>
    function bulkSendMessage(item) {
        let id = $(item).data('id');
        $.ajax({
            method: 'POST',
            url: "{{ route('admin-message-send') }}",
            data: {
                id: id,
            },
            success: function() {
                console.log($(item).parent().find('.message-cancel').css('display', 'inline-block'));
                console.log($(item).parent().find('.message-send').css('display', 'none'));

                new PNotify({
                    title: "Сообщение отправлено",
                    type: "success"
                });

            }
        });
    }

    function bulkCancelMessage(item) {
        let id = $(item).data('id');
        $.ajax({
            method: 'POST',
            url: "{{ route('admin-message-cancel') }}",
            data: {
                id: id,
            },
            success: function() {
                console.log($(item).parent().find('.message-cancel').css('display', 'none'));
                console.log($(item).parent().find('.message-send').css('display', 'inline-block'));

                new PNotify({
                    title: "Сообщение отменено",
                    type: "success"
                });

            }
        });
    }
</script>
