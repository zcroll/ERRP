<?php

namespace App\Filament\Resources\USER_AND_ROLE\EventResource\Widgets;

use App\Filament\Resources\USER_AND_ROLE\EventResource;
use App\Models\Event;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public string|null|\Illuminate\Database\Eloquent\Model $model = Event::class;
    protected static ?string $navigationGroup = 'User Management ';

    public function fetchEvents(array $info): array
    {

        return Event::query()
            ->where('start_time', '>=', $info['start'])
            ->where('end_time', '<=', $info['end'])
            ->get()
            ->map(
                function (Event $event) {
                    return [
                        'title' => $event->title,
                        'start' => $event->start_time,
                        'end' => $event->end_time,
                        'url' => EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                        'shouldOpenUrlInNewTab' => true,
                    ];
                }
            )
            ->all();
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            Grid::make()->schema([
                DatePicker::make('start_time')->required(),
                DatePicker::make('end_time')->required(),
            ])->columns(2),
        ];
    }
}
