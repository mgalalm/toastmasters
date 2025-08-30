<?php

namespace App\Enums;

enum Role: string
{
    case TIME_KEEPER = 'TIME_KEEPER';
    case GENERAL_EVALUATOR = 'GENERAL_EVALUATOR';
    case WORD_MASTER = 'WORD_MASTER';
    case TOAST_MASTER = 'TOAST_MASTER';
    case PRESIDENT = 'PRESIDENT';
    case TOPICS_MASTER = 'TOPICS_MASTER';

}
