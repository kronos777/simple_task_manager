jQuery(document).ready(function ($) {

    function onClickRemove() {
        jQuery('.btn-danger').on('click', function (e) {
            e.preventDefault();
            var idTask = jQuery(this).attr('data-value');
            var taskElement = jQuery(this);
            jQuery.ajax({
                type: 'POST',
                data: {
                    deleteTask: 'deleteTask',
                    id: idTask
                },
                url: window.location,
                success: function (resp) {
                    taskElement.parent().parent().remove();
                },
                error: function () {
                    alert('Error')
                }
            });

        });
    }
	
	function onClickChange() {
        jQuery('.btn.btn-change-status').on('click', function (e) {
            var tableHtmlFree = jQuery(this).parent().parent().parent().parent().parent();
            var statusChange = jQuery(this).attr('name');

            if(statusChange == "submit_mark_complete") {
                let idTask = jQuery(this).parent().find('input[name="mark_as_complete_id"]').val();
                let statusTask = jQuery(this).parent().find('input[name="mark_as_complete_status"]').val();
                jQuery.ajax({
                    type: 'POST',
                    datatype: "html",
                    data: {
                        submit_mark_complete: 'submit_mark_complete',
                        mark_as_complete_id: idTask,
                        mark_as_complete_status: statusTask

                    },
                    url: window.location,
                    success: function () {
                        changeHtml(window.location, tableHtmlFree);
                    },
                    error: function () {
                        alert('Error')
                    }
                });
            } else if (statusChange == "submit_mark_pending") {
                let idTask = jQuery(this).parent().find('input[name="mark_as_pending_id"]').val();
                let statusTask = jQuery(this).parent().find('input[name="mark_as_pending_status"]').val();
                jQuery.ajax({
                    type: 'POST',
                    datatype: "html",
                    data: {
                        submit_mark_pending: 'submit_mark_pending',
                        mark_as_pending_id: idTask,
                        mark_as_pending_status: statusTask

                    },
                    url: window.location,
                    success: function () {
                        changeHtml(window.location, tableHtmlFree);
                    },
                    error: function () {
                        alert('Error')
                    }
                });
            }


        });
    }

	function changeHtml(url, tableHtmlFree) {
		jQuery.get( url, function( data ) {
			var tbodySuccess = jQuery(data).find('.table-view-list').html();
			tableHtmlFree.html(tbodySuccess);
         //   onClickChange();
           // onClickRemove();
		});
	}


    function onClickUpdateData() {
        jQuery('#updateData').on('click', function (e) {
            jQuery(this).hide();
            jQuery.ajax({
                type: 'POST',
                data: {
                    updateData: 'updateData',
                },
                url: window.location,
                success: function () {
                    window.location.reload();
                },
                error: function () {
                    alert('Error')
                }
            });

        });
    }

    function onClickRefreshData() {
        jQuery('#refresh').on('click', function (e) {
            window.location.reload();
        });
    }

    function searchTitleData() {
        jQuery('.btn-search').on('click', function (e) {
           var tableHtml = jQuery('.table-view-list tbody');
           e.preventDefault();
           var searchTitle = jQuery('[name="searchTitle"]').val();
           jQuery.ajax({
                type: 'POST',
                datatype: "html",
                data: {
                    searchTitleFun: searchTitle,
                },
                url: window.location,
                success: function (data) {
                    var dataSearch = jQuery(data).find('.table-view-list tbody').html();
                   // alert(dataSearch);
                    //  changeHtml(window.location, tableHtml);
                    //taskElement.parent().parent().remove();
                    tableHtml.html(dataSearch);
                },
                error: function () {
                    alert('Error')
                }
            });

        });
    }

    searchTitleData();
    onClickUpdateData();
    onClickRefreshData();


});