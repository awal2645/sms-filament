<?php

namespace App\Filament\Resources;

use App\Exports\StudentExport;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Section;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Filters\SelectFilter;


class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationGroup = 'Academic Mangement';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->required()
                    ->autofocus()
                    ->placeholder('Enter  Name'),
                TextInput::make('email')
                    ->required()
                    ->autofocus()
                    ->unique(ignoreRecord: true)
                    ->placeholder('Enter Email'),
                TextInput::make('phone_number')
                    ->required()
                    ->tel()
                    ->unique(ignoreRecord: true)
                    ->placeholder('Enter Phone Number'),
                TextInput::make('address')
                    ->required()
                    ->autofocus()
                    ->placeholder('Enter Address'),
                Select::make('class_id')
                    ->relationship('class', 'name')
                    ->reactive(),
                Select::make('section_id')->options(function (callable $get) {
                    $classId = $get('class_id');
                    if ($classId) {
                        return Section::where('class_id', $classId)
                            ->pluck('name', 'id')
                            ->toArray();
                    }
                }),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable()->toggleable(),
                TextColumn::make('email')->sortable()->searchable()->toggleable(),
                TextColumn::make('class.name')->sortable()->searchable(),
                TextColumn::make('section.name')->sortable()->searchable(),
                TextColumn::make('phone_number')->sortable()->searchable()->toggleable(),
                TextColumn::make('address')->sortable()->searchable()->toggleable()->wrap(),
              
            ])
            ->filters([
                SelectFilter::make('class_id')->relationship('class', 'name')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), 
                Tables\Actions\EditAction::make(), 
                Tables\Actions\DeleteAction::make(),
                Action::make('Download Pdf')
                ->icon('heroicon-o-document-download')
                ->url(fn(Student $record) => route('student.pdf.download',$record))
                ->openUrlInNewTab(),

                 ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make(),
            BulkAction::make('Export')->label('Export To  Excel File ')->icon('heroicon-o-document-download')
            ->action(fn (Collection $records) => (new StudentExport($records))->download('students.xlsx'))
        ]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
    protected static function getNavigationBadge(): ?string
    {
        return Student::count();
    }
}
