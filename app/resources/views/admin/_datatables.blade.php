<script>
    $(document).ready( function () {
        $('{{ $tableId }}').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "order": [[{{ $orderIndex }}, "{{ $orderDirection ?? 'desc' }}"]], // The 'ID' column index
            columnDefs: [
                { targets: 'no-sort', orderable: false  }
            ]
        });
    });
</script>
