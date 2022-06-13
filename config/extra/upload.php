<?php
return [
    'method' => 'local',//local-本地，oss-阿里云oss，qiniu-七牛云,
    'fileSizeLimit' => 2 * 1024 * 1024,//文件大小限制
    'defaultPath' => PUBLIC_PATH . 'upload/',//默认保存路径,
    'enable_type' => ['jpg', 'png', 'jpeg']
];