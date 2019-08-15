<?php 
            function formatPrice($price) {
                $price = ceil($price);
                if ($price >= 1000) {
                    $price = number_format($price, 0, ',', ' ');
                }

                $price = $price . "<b class='rub'>p</b>";
                
                return $price;
            }
            