<?php
/**
 * Created by PhpStorm.
 * User: leksgit
 * Date: 30.04.2017
 * Time: 13:32
 */

date_default_timezone_set('Europe/Kiev');

//Ссылка на поток Rss
if (isset($_POST['rss']) and !empty($_POST['rss']))
    $link_rss = $_POST['rss'];
else
    $link_rss = 'https://habrahabr.ru/rss/interesting/';


$xml = new DOMDocument();

//забираем поток и грузим в объект, если поток не найден убиваем процесс и говорим что беда
$xml->load($link_rss) or die("Поток не найден или недоступен");

//Собираем данные о потоке
$channel = $xml->getElementsByTagName('channel')->item(0);

//Используем parsed для большей читаемости кода
$data['name'] = parsed($channel, 'title');
$data['link'] = parsed($channel, 'link');
$data['desc'] = parsed($channel, 'description');
$data['site'] = parsed($channel, 'generator');

$data['body_table'] = '';

//Собираем все статьи в 1 строку для вставки в шаблон
$items = $xml->getElementsByTagName('item');

for ($i = 0; $i < $items->length; $i++) {

    $item_title = parsed($items->item($i), 'title');
    $item_link = parsed($items->item($i), 'link');
    $item_desc = parsed($items->item($i), 'description');
    $item_date = parsed($items->item($i), 'pubDate');

    //приводим к часовому поясу того кто просматривает Rss
    $item_date = date('Y-m-d H:s', strtotime($item_date));

    //Собираем категории поста в отдельную строку
    $category_table = '<ul>';
    $category = $items->item($i)->getElementsByTagName('category');
    for ($c = 0; $c < $category->length; $c++) {
        $category_table .= '<li>' . $category->item($c)->nodeValue . '</li>';
    }
    $category_table .= '</ul>';

    //Строка с отдельной записью
    $data['body_table'] .= '<tr>
                        <td>
                            <a href="' . $item_link . '" target="_blank">' . $item_title . '</a>
                            <p class="date">' . $item_date . '</p>
                        </td>
                        <td>' . $item_desc . '</td>
                        <td>' . $category_table . '</td>
                    </tr>';
}

//микрошаблонизатор для разделения основной логики и отображения

$ext_template = file_get_contents('index.tpl');

foreach ($data as $key => $value) {
    $ext_variable = "{:" . $key . ":}";
    if (!is_null($value)) {
        $ext_template = str_replace($ext_variable, $value, $ext_template);
    } else {
        $ext_template = str_replace($ext_variable, '', $ext_template);
    }
}

echo $ext_template;


function parsed(DOMElement $obj, $name)
{
    return $obj->getElementsByTagName($name)->item(0)->childNodes->item(0)->nodeValue;
}
