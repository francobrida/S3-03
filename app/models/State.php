<?php
    Enum State : string {
        case pending = 'pending';
        case inProgress = 'inProgress';
        case completed = 'completed';

        public function label(): string
        {
            return match($this) {
                self::pending => 'Pendiente',
                self::inProgress => 'En progreso',
                self::completed => 'Completada',
            };
        }
    }
?>