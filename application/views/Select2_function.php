<script>
    const siteUrl = '<?= site_url() ?>';

    initailizeSelect2_barang();

    function initailizeSelect2_barang() {
        $('.select2_barang').select2({
            width: '100%',
            heigh: 'auto',
            allowClear: true,
            placeholder: $(this).data('placeholder'),
            multiple: false,
            dropdownAutoWidth: true,
            language: {
                inputTooShort: function() {
                    return 'Ketikan minimal 2 huruf';
                }
            },
            ajax: {
                url: siteUrl + 'Select2_master/data_barang',
                type: 'POST',
                dataType: 'JSON',
                delay: 100,
                data: function(params) {
                    return {
                        searchTerm: params.term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }
</script>