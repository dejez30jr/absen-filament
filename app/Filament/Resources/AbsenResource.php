<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Absen;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\QueryException;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AbsenResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AbsenResource\RelationManagers;

class AbsenResource extends Resource {
    protected static ?string $model = Absen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected function mutateFormDataBeforeCreate( array $data ): array {
        $tanggal = Carbon::today();

        $sudahAbsen = Absen::where( 'user_id', auth()->id() )
        ->whereDate( 'created_at', $tanggal )
        ->exists();

        if ( $sudahAbsen ) {
            Notification::make()
            ->title( 'Absen Gagal' )
            ->body( 'Kamu sudah melakukan absen hari ini 🙌' )
            ->danger()
            ->send();

            abort( 403 );
            // hentikan proses create
        }

        return $data;
    }

    public static function form( Form $form ): Form {
        return $form
        ->schema( [
            Hidden::make( 'user_id' )
            ->default( fn () => auth()->id() ),
            Hidden::make( 'tanggal_absen' )
            ->default( now()->toDateString() ),
            TextInput::make( 'nama' )
            ->default( fn () => auth()->user()->name )
            ->disabled()
            ->dehydrated(),
            TextInput::make( 'nis' )
            ->default( fn () => auth()->user()->nis )
            ->disabled()
            ->dehydrated(),
            Select::make( 'jurusan' )
            ->options( [
                'RPL' => 'RPL',
                'mp' => 'mp',
                'akl' => 'akl',
            ] ),
            Select::make( 'kelas' )
            ->options( [
                'X' => 'X',
                'XI' => 'XI',
                'XII' => 'XII',
            ] ),
            Select::make( 'status' )
            ->options( [
                'Hadir' => 'Hadir',
                'Sakit' => 'Sakit',
                'Izin' => 'Izin',
            ] ),
        ] );
    }

    public static function table( Table $table ): Table {
        return $table
        ->columns( [
          TextColumn::make('nama')->label('nama')->searchable(),
          TextColumn::make('nis')->label('NIS'),
          TextColumn::make('tanggal_absen')->label('tanggal absen'),
          TextColumn::make('jurusan')->label('jurusan')->searchable(),
          TextColumn::make('kelas')->label('kelas')->searchable(),
        ] )
        ->filters( [
            //
        ] )
        ->actions( [
            // Tables\Actions\EditAction::make(),
        ] )
        ->bulkActions( [
            Tables\Actions\BulkActionGroup::make( [
                Tables\Actions\DeleteBulkAction::make(),
            ] ),
        ] );
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListAbsens::route( '/' ),
            'create' => Pages\CreateAbsen::route( '/create' ),
            'edit' => Pages\EditAbsen::route( '/{record}/edit' ),
        ];
    }

    public function create(User $user)
{
    return $user->is_admin;
}

public function update(User $user, Absen $absens)
{
    return $user->is_admin;
}

public function delete(User $user, Absen $absens)
{
    return $user->is_admin;
}

}
