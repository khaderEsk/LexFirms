<?php

namespace App\Enum;

enum CauseStatus: string
{
    case LS = 'LS';
    case CC = 'CC';
    case CIP = 'CIP';


    /**
     * This is the "state machine" logic.
     * It defines all valid transitions from one status to another.
     */
    // public function canTransitionTo(self $nextState): bool
    // {
    //     return match ($this) {
    //         self::WAITING        => in_array($nextState, [self::APPROVED, self::REJECTED]),
    //         self::APPROVED       => in_array($nextState, [self::PROCESSING]),
    //         self::PROCESSING     => in_array($nextState, [self::UNDER_DELIVERY]),
    //         self::UNDER_DELIVERY => in_array($nextState, [self::COMPLETED]),
    //         self::REJECTED, self::COMPLETED => false,
    //     };
    // }

    // /**
    //  * This is your existing helper method to convert a string to an Enum case.
    //  */
    // public static function fromString(string $stringStatus): ?self
    // {
    //     return match (strtolower($stringStatus)) {
    //         'rejected' => self::REJECTED,
    //         'waiting' => self::WAITING,
    //         'approved' => self::APPROVED,
    //         'processing' => self::PROCESSING,
    //         'under delivery' => self::UNDER_DELIVERY,
    //         'completed' => self::COMPLETED,
    //         default => self::WAITING,
    //     };
    // }
}
