<?php

if (isset($_GET['page'])){
    $page="frontend/{$_GET['page']}";
}
else{
    $page="frontend/index.html.twig";
}

include $page;
?>