<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AnnouncementRepository;
use App\Models\Announcement;

/**
 * Class AnnouncementRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AnnouncementRepositoryEloquent extends BaseRepository implements AnnouncementRepository
{
    public function model()
    {
        return Announcement::class;
    }

    protected $fieldSearchable = [
        'title' => 'like',
        'short_description' => 'like',
    ];


    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $announcements = $this->find($id);
            $announcements->guidelines()->detach();
            $announcements->interests()->detach();
            $announcements->skills()->detach();
            $announcements->submissions()->delete();
            $announcements->delete();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            return false;
        }
    }
}
