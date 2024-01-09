<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Inscription;
use App\Models\Submission;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CreativeDataRepository;
use App\Models\CreativeData;

/**
 * Class CreativeDataRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CreativeDataRepositoryEloquent extends BaseRepository implements CreativeDataRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CreativeData::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function delete($id)
    {
        DB::beginTransaction();
        Schema::disableForeignKeyConstraints();
        try {
            $creativeDatum = $this->find($id);
            $creativeDatum->interests()->detach();
            $creativeDatum->skills()->detach();
            $creativeDatum->account->user->logs()->delete();
            foreach ($creativeDatum->subscriptions as $submission) {
                $submission->skills()->detach();
                Submission::whereIn('inscription_id', $creativeDatum->inscriptions()->pluck('id')->all())->delete();
            }

            Inscription::where('creative_data_id', $id)->delete();

            $creativeDatum->account->user->delete();
            $creativeDatum->account->delete();
            $creativeDatum->delete();
            DB::commit();
            //DB::rollBack();
            Schema::enableForeignKeyConstraints();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Schema::enableForeignKeyConstraints();
            throw $e;
            return false;
        }
    }
}
