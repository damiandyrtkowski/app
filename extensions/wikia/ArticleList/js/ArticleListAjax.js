
/**
 * Created with JetBrains PhpStorm.
 * User: Damian
 * Date: 05.09.13
 * Time: 18:07
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function () {
    $(".article_list_button").click(function () {
        //alert(wgScript);
        //var a = $(this).attr("value");
        $.nirvana.sendRequest({
            controller: 'ArticleListAjax',
            method: 'index',
            format: 'json',
            data:
            {
                category: $(this).attr("data-type-value"),
                title: $(this).attr("data-title")
            },
            callback: function (data) {

                alert(data['result']+" "+data['title']);
            }});
    });
});

