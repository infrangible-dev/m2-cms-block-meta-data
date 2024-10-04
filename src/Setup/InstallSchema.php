<?php

declare(strict_types=1);

namespace Infrangible\CmsBlockMetaData\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @author      Andreas Knollmann
 * @copyright   Copyright (c) 2014-2024 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $connection = $setup->getConnection();

        $connection->startSetup();

        $blockTableName = $connection->getTableName('cms_block');

        if (! $connection->tableColumnExists(
            $blockTableName,
            'meta_title'
        )) {
            $connection->addColumn(
                $blockTableName,
                'meta_title',
                [
                    'type'     => Table::TYPE_TEXT,
                    'length'   => 255,
                    'nullable' => true,
                    'comment'  => 'Block Meta Title'
                ]
            );
        }

        if (! $connection->tableColumnExists(
            $blockTableName,
            'meta_keywords'
        )) {
            $connection->addColumn(
                $blockTableName,
                'meta_keywords',
                [
                    'type'     => Table::TYPE_TEXT,
                    'length'   => 4096,
                    'nullable' => true,
                    'comment'  => 'Block Meta Keywords'
                ]
            );
        }

        if (! $connection->tableColumnExists(
            $blockTableName,
            'meta_description'
        )) {
            $connection->addColumn(
                $blockTableName,
                'meta_description',
                [
                    'type'     => Table::TYPE_TEXT,
                    'length'   => 4096,
                    'nullable' => true,
                    'comment'  => 'Block Meta Description'
                ]
            );
        }

        $connection->endSetup();
    }
}
