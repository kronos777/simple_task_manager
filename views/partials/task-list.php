<table class="wp-list-table widefat fixed striped table-view-list pages">
        <thead>
            <tr>
                <th width="25%">id</th>
                <th width="25%">Название</th>
                <th width="25%">Пользователь</th>
                <th width="25%">Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task) :

                if($task->completed == 0) {
                    $completed = "false";
                } else {
                    $completed = "true";
                }
                ?>

                <tr>
                    <td width="25%"><?php echo esc_attr( $task->id ); ?></td>
                    <td width="25%"><?php echo esc_attr( $task->title ); ?></td>
                    <td width="25%"><?php echo esc_attr( $task->userId ); ?></td>
                    <td width="25%"><?php echo esc_attr( $completed ); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>