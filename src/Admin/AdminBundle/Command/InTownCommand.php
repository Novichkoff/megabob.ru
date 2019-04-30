<?php

namespace Admin\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;

class InTownCommand extends ContainerAwareCommand
{

    # Форматирование склонения для городов
    protected function configure()
    {
        $this
            ->setName('cron:inTown')
            ->setDescription('In Town Task')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
        $areas = AreasQuery::create()->find();
        foreach ($areas as $town) {          
          
          $tags = $this->getNewFormText($town->getName());
          if (@$tags[5]) {             
            $town->setPagetitle('в '.$tags[5]);
          } else {            
            $town->setPagetitle('в '.$town->getName());
          }
          //$alias = $this->str2url($town->getName());
          //$town->setAlias($alias);
          $output->writeln($town->getName()." => ".$town->getPagetitle());
          //$town->save();
        }
        */
        $regions = AreasQuery::create()            
            //->where('net is null')
            ->where('net is ""')
            //->limit(20)
            ->find();
        
        foreach ($regions as $region) {          
          /*
          $new_form = (string)$this->getNewFormText($region->getName());          
          if ($new_form) {
            $new_form = mb_convert_case($new_form, MB_CASE_TITLE, "UTF-8");          
            $output->writeln($new_form);
            $region->setNet($new_form);
            $region->save();
            sleep(2);
          }
            $string = $region->getNet();
            $patterns = '/Обл./';
            $replacements = 'области';
            $new_form = preg_replace($patterns, $replacements, $string);
            $output->writeln($new_form);
            $region->setNet($new_form);
            $region->save();
            */
            $output->writeln($region->getName());
            $output->writeln($region->getNet());
        }
        
        /*
        $categoryfields = AdCategoriesFieldsValuesQuery::create()->find();
        foreach ($categoryfields as $categoryfield) {
          //if (!$categoryfield->getTitle()) $categoryfield->setTitle($categoryfield->getName());
          if (!$categoryfield->getAlias()) $categoryfield->setAlias($this->str2url($categoryfield->getName()));
          $output->writeln($categoryfield->getAlias());
          $categoryfield->save();
        }
        */
        
        $output->writeln('ok');
    }
    
    function getNewFormText($text){
      $urlXml = $this->get_page("http://pyphrasy.herokuapp.com/inflect?phrase=".urlencode($text)."&cases=gent");
      $result = @json_decode($urlXml);
      if($result){
          $arrData = array();
          foreach ($result as $one) {
             $arrData[] = (string)$one;
          }
          return $arrData[0];
      }
      return false;
    }
    
    function rus2translit($string) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '',  'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            
            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }
    
    function str2url($str) {
        // переводим в транслит
        $str = $this->rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '_', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }
    
    function ucname($string) {
        $string =ucwords(strtolower($string));

        foreach (array('-', '\'') as $delimiter) {
          if (strpos($string, $delimiter)!==false) {
            $string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
          }
        }
        return $string;
    }
    
    function get_page($url) {		
		
      $ch = curl_init();  
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_FAILONERROR, 1);  
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);
      curl_setopt($ch, CURLOPT_USERAGENT, "Googlebot");
      curl_setopt($ch, CURLOPT_TIMEOUT, 3);
      $result = curl_exec($ch);
      curl_close($ch);   
      return $result; 
      
    }
    
}