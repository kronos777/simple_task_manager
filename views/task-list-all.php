<?php
    if (isset($_POST['searchTitleFun'])) {
        $title = $_POST['searchTitleFun'];
        $tasks = ZISWP_getTaskListsTitleOption($title);
    } else {
        $tasks = ZISWP_getTaskListsTitleOption();
    }
?>
<div class="wrap akash-crud-task-area">
     <div class="header">
        <h1 class="wp-heading-inline">Задачи</h1>
         <? if(ZISWP_countTaskLists() == 0):  ?>
            <button class="btn btn-primary" id="updateData">обновить данные</button>
        <? else:  ?>
             <button class="btn btn-primary" id="refresh">обновить данные</button>
        <? endif;  ?>
        <form action="" method="POST">
            <input type="text"  name="searchTitle">
            <button type="submit" class="btn btn-primary btn-search" title="Search by title"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <?php require_once(ZISWP_AK_TASK__PLUGIN_DIR . 'views/partials/task-list.php'); ?>
</div>
<?php require_once(ZISWP_AK_TASK__PLUGIN_DIR . 'functions/actions.php'); ?>