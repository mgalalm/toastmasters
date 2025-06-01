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

    // List all pathways as an array pair of pathway name and value dynamically
    public static function allPathways(): array
    {
        return array_map(fn ($pathway) => [
            'value' => $pathway->name,
            'label' => $pathway->value,
        ], self::cases());
    }
}
