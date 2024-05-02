<?php

    $output = '<ul class="dropdown-menu" style="display:block; position:relative;width:100%;">';
    foreach($data as $row)

    {
        $output .= '
        <li><a class="dropdown-item" href="#">'.$row->name_ingredient.'</a></li>
        ';
    }
    $output .= '</ul>';
    echo $output;
  
?>