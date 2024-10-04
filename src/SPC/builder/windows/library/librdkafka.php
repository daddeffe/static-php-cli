<?php

declare(strict_types=1);

namespace SPC\builder\windows\library;

use SPC\store\FileSystem;

class librdkafka extends WindowsLibraryBase
{
    public const NAME = 'librdkafka';

    protected function build(): void
    {
        $zlib = $this->builder->getLib('zlib') ? 'ON' : 'OFF';

        // reset cmake
        FileSystem::resetDir($this->source_dir . '\build');

        // start build
        cmd()->cd($this->source_dir)
            ->execWithWrapper(
                $this->builder->makeSimpleWrapper('cmake'),
                '-B build ' .
                '-A x64 ' .
                "-DCMAKE_TOOLCHAIN_FILE={$this->builder->cmake_toolchain_file} " .
                '-DCMAKE_BUILD_TYPE=Release ' .
                '-DSKIP_INSTALL_PROGRAM=ON ' .
                '-DSKIP_INSTALL_FILES=ON ' .
                '-DBUILD_SHARED_LIBS=OFF ' .
                '-DLIBRDKAFKA_STATICLIB ' .
                '-DLIBRDKAFKA_STATIC=ON ' .
 //               '-DLIBRDKAFKA_SHARED=OFF ' .
                "-DENABLE_ZLIB_COMPRESSION={$zlib} " .
                "-DENABLE_CURL=OFF" .
                "-DENABLE_SASL=OFF" .
                "-DENABLE_SSL=OFF" .
                '-DLIBRDKAFKA_TESTS=OFF ' .
                '-DCMAKE_INSTALL_PREFIX=' . BUILD_ROOT_PATH . ' '
            );
    }
}
