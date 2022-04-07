<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class readingPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:readingPdf {--filename=sample-text}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para testear lectura del contenido de un PDF';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = $this->option('filename').'.pdf';

        if (!Storage::exists($this->option('filename').'.pdf')) {
            $this->error("No existe el documento: ".$filename);
            $this->newLine();
            $filename = 'sample-text.pdf';
        }

        $this->info("Leyendo el texto encontrado en: ".$filename);
        $this->newLine();

        $filePath =Storage::path($filename);
        $parser = new Parser();
        $document = $parser->parseFile($filePath);
        $pages = $document->getPages();

        foreach ($pages as $index => $page) {
            $pageNum = ++$index;
            $text = $page->getText();

            $this->info("Pagina # ".$pageNum);
            $this->newLine();
            $this->line($text);
            $this->newLine();
        }
    }
}
