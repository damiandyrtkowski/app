<ul>
    <? foreach($list as $element): ?>
        <li>
           <a href = "<?=$element['title'];?>"> <?=$element['title'];?> </a>
        </li>
        <p><?=$element['snippet'];?> </p>
        <br>
    <? endforeach ; ?>
    <br>
<? if(($offset-$limit)>=0): ?>
<a href="<?php $prev = ($offset - $limit); echo $link.$prev ?>">previous</a>
<? endif  ?>

<? if($offset%$limit == 0 ):  ?>
<a href=<?php $next = ($offset + $limit);  echo $link.$next?>>next</a>
<? endif?>

</ul>