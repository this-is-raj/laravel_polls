<?php
namespace Raj\LaravelPoll\Traits;

use Illuminate\Support\Facades\DB;
use Raj\LaravelPoll\Exceptions\CheckedOptionsException;
use Raj\LaravelPoll\Exceptions\OptionsInvalidNumberProvidedException;
use Raj\LaravelPoll\Exceptions\OptionsNotProvidedException;
use Raj\LaravelPoll\Option;

trait PollCreator
{
    protected $options_add = [];
    protected $maxSelection = 1;

    /**
     * Add an option to the array if not exists
     *
     * @param $option
     * @return bool
     */
    private function pushOption($option)
    {
        if(! in_array($option, $this->options_add)){
            $this->options_add[] = $option;
            return true;
        }
        return false;
    }

    /**
     * Add new Options
     *
     * @param $options
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function addOptions($options)
    {
        if(is_array($options))
        {
            foreach($options as $option){
                if(is_string($option)){
                    $this->pushOption($option);
                }else{
                    throw new \InvalidArgumentException("Array arguments must be composed of Strings values");
                }
            }
            return $this;
        }

        if(is_string($options)){
            $this->pushOption($options);
            return $this;
        }

        throw new \InvalidArgumentException("Invalid Argument provided");
    }

    /**
     * Select max options to be voted by a user
     *
     * @param int $number
     * @return $this
     */
    public function maxSelection($number = 1)
    {
        if($number <= 1){
            $number = 1;
        }
        $this->maxSelection = $number;

        return $this;
    }

    /**
     * Generate the poll
     *
     * @return bool
     * @throws CheckedOptionsException
     * @throws OptionsInvalidNumberProvidedException
     * @throws OptionsNotProvidedException
     */
    public function generate()
    {
        $totalOptions = count($this->options_add);

        // No option add yet
        if($totalOptions == 0)
            throw new OptionsNotProvidedException();

        // There must be 2 options at least
        if($totalOptions == 1 )
            throw new OptionsInvalidNumberProvidedException();

        // At least one options should not be selected
        if($totalOptions <= $this->maxSelection )
            throw new CheckedOptionsException();

        // Create Poll && assign options to it
        DB::transaction(function () {
            $this->maxCheck = $this->maxSelection;
            $this->save();
            $this->options()
                ->saveMany($this->instantiateOptions());
        });

        return true;
    }

    /**
     * Instantiate the options
     *
     * @return array
     */
    private function instantiateOptions()
    {
        $options = [];
        foreach($this->options_add as $option){
            $options[] = new Option([
                'name' => $option
            ]);
        }

        return $options;
    }
}
