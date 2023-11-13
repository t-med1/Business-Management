function createDataTable(tableSelector, exportBtnsSelector = null, exportTitle = null)

{

    if ($(tableSelector).length > 0)

    {
        if(exportBtnsSelector != null)

        {

            var title = exportTitle != null ? exportTitle : document.title.replace("::", "").replace("::", "").trim();

            new $.fn.DataTable.Buttons(myTable, {

                buttons : [

                    {

                        extend : 'print', footer: true,

                        text : '<i class="fa fa-print" aria-hidden="true">&nbsp;&nbsp;Imprimer</i>',

                        title : title,

                        pageSize : 'A4',

                        orientation : 'landscape',

                        //orientation : 'portrait',

                        exportOptions: { columns: [':not(.no-export):not(:last-child)'], stripHtml: true }

                    },

                    {

                        extend: "excel", footer: true,

                        text : '<i class="fa fa-table" aria-hidden="true">&nbsp;&nbsp;Excel</i>',

                        title : title,

                        exportOptions: { columns: [':not(.no-export):not(:last-child)'], stripHtml: true }

                    }

                ]

            }).container().appendTo(exportBtnsSelector);

        }

    }

}