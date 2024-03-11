<?php
    namespace Mvc\Fixtures;

    use Faker\Factory as FakerGeneratorFactory;
    use Faker\Provider\Base as FakerDataProvider;
    use Faker\Generator as FakerGenerator;
    use Nelmio\Alice\Faker\Provider\AliceProvider;
    use Nelmio\Alice\Loader\NativeLoader;

    class AppNativeLoader extends NativeLoader {
        public const string LOCALE = 'fr_FR';

        protected function createFakerGenerator(): FakerGenerator
        {
            $generator = FakerGeneratorFactory::create(self::LOCALE);
            $generator->addProvider(new AliceProvider());
            $generator->seed($this->getSeed());

            $generator->addProvider(new FakerDataProvider($generator));

            return $generator;
        }
    }