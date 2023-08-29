<?php
/*
this file exists to separate instance data from the actual about page
 HTML, and to make it easier to add/modify instances cleanly.
*/
$instancelist = [
    [
        "name" => "lolcat's instance (master)",
        "address" => [
            "uri" => "https://4get.ca/",
            "displayname" => "4get.ca"
        ],
        "altaddresses" => [ // all these address blocks will be linked in parentheses
            [               // e.g. 4get.ca (tor) (i2p) etc.
                "uri" => "http://4getwebfrq5zr4sxugk6htxvawqehxtdgjrbcn2oslllcol2vepa23yd.onion",
                "displayname" => "tor"
            ]
        ]
    ],
    [
        "name" => "zzls's instance",
        "address" => [
            "uri" => "https://4get.zzls.xyz/",
            "displayname" => "4get.zzls.xyz"
        ],
        "altaddresses" => [
            [
                "uri" => "http://4get.zzlsghu6mvvwyy75mvga6gaf4znbp3erk5xwfzedb4gg6qqh2j6rlvid.onion",
                "displayname" => "tor"
            ]
        ]
    ],
    [
        "name" => "4get on a silly computer",
        "address" => [
            "uri" => "https://4get.silly.computer",
            "displayname" => "4get.silly.computer"
        ],
        "altaddresses" => [
            [
                "uri" => "https://4get.cynic.moe/",
                "displayname" => "fallback domain"
            ]
        ]
    ],
]
?>