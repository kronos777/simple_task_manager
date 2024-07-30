<?php
/**
 * Help function request
 *
 */
function ZISWP_request($url, $postdata = null, $cookfile = 'tmp/cookie.txt') {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (x11; Ubuntu; Linux86_64; rv:47.0) Gecko/20100101 Firefox/47.0');
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookfile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookfile);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if ($postdata) {

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

    }
    $html = curl_exec($ch);
    curl_close( $ch );

    return mb_strtolower($html);

}

/**
 * Get remote data and insert db
 *
 */
function ZISWP_getRemoteData() {
    $logger = new FileLogger();
    try {
       $data = ZISWP_request("https://jsonplaceholder.typicode.com/todos");
       $jsonData = json_decode($data);
       if (count($jsonData) > 0 && ZISWP_countTaskLists() == 0) {
           foreach($jsonData as $item) {
               $userid = $item->userid;
               $title = $item->title;
               $completed = $item->completed;
               ZISWP_createItem($userid, $title, $completed);
           }
           $logger->info('data insert db');
       } elseif (count($jsonData) == 0) {
           $logger->info('no internet connection');
       } else {
          $logger->info('no updates required');
       }
    } catch (\Exception $e) {
        $logger->error("error $e");
    }
}


/**
 * Create New Item
 *
 * @param string $userId
 * @param string $title
 * @param string $completed
 * @return Object Task Create Object
 */
function ZISWP_createItem($userId, $title, $completed)
{
    $logger = new FileLogger();
    global $wpdb;
    $table_name = $wpdb->prefix . ZISWP_TASK_TABLE_NAME;

    try {
        $wpdb->insert(
            $table_name,
            array(
                'title' => $title,
                'userId' => $userId,
                'completed' => $completed
            ),
            array('%s', '%s', '%s')
        );
    } catch (\Exception $e) {
        $logger->error("error $e");
    }

}



/**
 * Get Task Lists
 *
 * @param string $title
 * @return array tasks list
 */
function ZISWP_getTaskListsTitleOption($title = "")
{

    global $wpdb;
    $table_name = $wpdb->prefix . ZISWP_TASK_TABLE_NAME;

    $logger = new FileLogger();

    if($title == "") {
        $sql = "SELECT * FROM $table_name ORDER BY id ASC LIMIT 200";
        $sql_prep = $wpdb->prepare($sql);
        $logger->debug('get all data');
    } else {
        $title = trim($title);
        $sql = "SELECT * FROM $table_name WHERE title LIKE '%$title%' ORDER BY id ASC LIMIT 200";
        $sql_prep = $wpdb->prepare($sql);
        $logger->debug('get data from title');
    }


    return $wpdb->get_results($sql_prep);
}


function ZISWP_getRandListsForShortCode()
{
    global $wpdb;

    $logger = new FileLogger();
    $logger->info('short code call');

    $table_name = $wpdb->prefix . ZISWP_TASK_TABLE_NAME;
    $sql = "SELECT * FROM $table_name WHERE completed = 0 ORDER BY rand() LIMIT 5";
    $sql_prep = $wpdb->prepare($sql);
    return $wpdb->get_results($sql_prep);
}


function ZISWP_get_random_news_shortcode() {
    ob_start();

    $tasks = ZISWP_getRandListsForShortCode();
    $str = '<table id="dataSearch"><thead>
            <tr>
                <th width="25%">id</th>
                <th width="25%">Название</th>
                <th width="25%">Пользователь</th>
                <th width="25%">Статус</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($tasks as $task) {
        if($task->completed == 0) {
            $completed = "false";
        } else {
            $completed = "true";
        }
        $str .= '<tr>';
        $str .= '<td width="25%">'. $task->id  .'</td>';
        $str .= '<td width="25%">'. $task->title . '</td>';
        $str .= '<td width="25%">'. $task->userId . '</td>';
        $str .= '<td width="25%">'. $completed . '</td>';
        $str .= '</tr>';
    }
    $str .= '</tbody></table>';
    echo $str;

    // end output buffering, grab the buffer contents, and empty the buffer
    return ob_get_clean();
}

add_shortcode( 'get_random_news', 'ZISWP_get_random_news_shortcode' );


/**
 * Count Task List
 *
 * @return total
 */
function ZISWP_countTaskLists()
{
    global $wpdb;
    $table_name = $wpdb->prefix . ZISWP_TASK_TABLE_NAME;

    $query = "SELECT COUNT(id) as total FROM $table_name";
    $sql_prep = $wpdb->prepare($query);

    $total = $wpdb->get_var($sql_prep);
    if (is_null($total) || $total === "")
        $total = 0;

    return $total;
}






