<?php

namespace App\Services;

// Import Factory untuk Stemmer dan StopWordRemover
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\StopWordRemover\StopWordRemoverFactory; 
// use App\Models\Skripsi; 

class IrService
{
    protected $stemmer;
    protected $stopWordRemover;

    public function __construct()
    {
        // 1. Siapkan Stemmer (Pecah kata berimbuhan)
        $stemmerFactory = new StemmerFactory();
        $this->stemmer  = $stemmerFactory->createStemmer();

        // 2. Siapkan StopWordRemover (Otomatis dari Library Sastrawi)
        // Ini sudah berisi daftar lengkap: yang, di, ke, dari, dll.
        $stopWordFactory = new StopWordRemoverFactory();
        $this->stopWordRemover = $stopWordFactory->createStopWordRemover();
    }

    /**
     * TAHAP 1: Preprocessing
     */
    public function preprocessing($text)
    {
        // a. Case Folding
        $text = strtolower($text);

        // b. Cleaning (Hanya huruf a-z)
        $text = preg_replace('/[^a-z\s]/', '', $text); 

        // c. Stopword Removal (PAKAI LIBRARY)
        // Fungsi ini bisa otomatis membuang kata misal "yang", "di", "dan", dll dari kalimat
        $text = $this->stopWordRemover->remove($text);

        // d. Tokenizing
        $tokens = explode(' ', $text);

        $cleanedTokens = [];
        
        foreach ($tokens as $word) {
            $word = trim($word);
            
            // Hapus kata yang tersisa jika cuma 1 huruf atau kosong
            if (empty($word) || strlen($word) < 2) continue;

            // e. Stemming
            $stemmedWord = $this->stemmer->stem($word);
            
            if (!empty($stemmedWord)) {
                $cleanedTokens[] = $stemmedWord;
            }
        }

        return $cleanedTokens;
    }
    
    public function computeTF($tokens)
    { 

        $tf = [];
        $total = count($tokens);
        if ($total == 0) return [];
        $counts = array_count_values($tokens);
        foreach ($counts as $word => $count) {
            $tf[$word] = $count / $total;
        }

        return $tf;
    }

    public function computeIDF($allDocsTokens)
    {
        $N = count($allDocsTokens);
        $idf = [];
        $allWords = [];
        foreach ($allDocsTokens as $tokens) {
            foreach (array_unique($tokens) as $word) {
                $allWords[] = $word;
            }
        }
        $uniqueWords = array_unique($allWords);
        foreach ($uniqueWords as $word) {
            $df = 0;
            foreach ($allDocsTokens as $tokens) {
                if (in_array($word, $tokens)) {
                    $df++;
                }
            }
            $df = ($df == 0) ? 1 : $df;
            $idf[$word] = log10($N / $df);
        }
        return $idf;
    }

    public function computeCosineSimilarity($queryTokens, $docTokens, $idf)
    {
        $vocab = array_unique(array_merge($queryTokens, $docTokens));
        $tfQuery = $this->computeTF($queryTokens);
        $tfDoc   = $this->computeTF($docTokens);
        $vecQuery = [];
        $vecDoc = [];
        foreach ($vocab as $term) {
            $termIdf = $idf[$term] ?? 0;
            $tfQ = $tfQuery[$term] ?? 0;
            $vecQuery[] = $tfQ * $termIdf;
            $tfD = $tfDoc[$term] ?? 0;
            $vecDoc[] = $tfD * $termIdf;
        }
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;
        for ($i = 0; $i < count($vecQuery); $i++) {
            $valA = $vecQuery[$i];
            $valB = $vecDoc[$i];
            $dotProduct += ($valA * $valB);
            $normA += ($valA * $valA);
            $normB += ($valB * $valB);
        }
        $normA = sqrt($normA);
        $normB = sqrt($normB);
        if ($normA == 0 || $normB == 0) return 0;
        return $dotProduct / ($normA * $normB);
    }
}