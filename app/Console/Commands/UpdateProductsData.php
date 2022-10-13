<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Http\Controllers\ProductController;
class UpdateProductsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update price history and price all products in db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $obj = new ProductController();
        $obj->cronJobUpdateProducts(new Product);
    }
}
