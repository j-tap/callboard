<?php

namespace App\Jobs\Geo;

use App\Models\Org\Organization;
use App\Services\Yandex\GeoCoder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GeoCodeOrganizationAddress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $organization;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $geoAddr = (new GeoCoder())->getBestAddress($this->organization->city->name . ' ' . $this->organization->org_address);
        $geoAddrLegal = (new GeoCoder())->getBestAddress($this->organization->city->name . ' ' . $this->organization->org_address);

        if ($geoAddr) {
            $latlon = explode(' ', $geoAddr['Point']['pos']);
            $this->organization->org_address = $geoAddr['name'];
            $this->organization->geo_lat = $latlon[1];
            $this->organization->geo_lon = $latlon[0];
        }
        if ($geoAddrLegal) {
            $this->organization->org_address_legal = $geoAddrLegal['name'];
        }

        $this->organization->save();
    }
}
