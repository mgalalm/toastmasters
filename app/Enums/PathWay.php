<?php

namespace App\Enums;

enum PathWay: string
{
    // List toastmasters pathways
    case DynamicLeadership = 'Dynamic Leadership';
    case EffectiveCoaching = 'Effective Coaching';
    case EngagingHumor = 'Engaging Humor';
    case InnovativePlanning = 'Innovative Planning';
    case LeadershipDevelopment = 'Leadership Development';
    case MotivationalStrategies = 'Motivational Strategies';
    case PresentationMastery = 'Presentation Mastery';
    case StrategicRelationships = 'Strategic Relationships';
    case TeamCollaboration = 'Team Collaboration';
    case VisionaryCommunication = 'Visionary Communication';
    case PublicRelations = 'Public Relations';
    case MasteringTheToast = 'Mastering the Toast';
    case NotApplicable = 'Not Applicable';
    case Other = 'Other';

    // get values as an array
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
