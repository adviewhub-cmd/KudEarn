<?php

namespace App\Enums;

enum TaskType: string
{
    case None = 'none';

    case Website = 'website';

    case Video = 'video';

    case Survey = 'survey';

    case Social = 'social';

    case Telegram = 'telegram';

    case Facebook = 'facebook';

    case Instagram = 'instagram';

    case TikTok = 'tiktok';

    case X = 'x';

    case AppInstall = 'app_install';
}