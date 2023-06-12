
<textarea class="ckeditor" name="{{ $field['name'] }}">
    {{ old_empty_or_null($field['name'], '') ??  $field['value'] ?? $field['default'] ?? '' }}
</textarea>

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>
