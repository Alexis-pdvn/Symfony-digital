<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426083655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_variant_product ADD product_id INT DEFAULT NULL, ADD product_variant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_variant_product ADD CONSTRAINT FK_8E642C764584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_variant_product ADD CONSTRAINT FK_8E642C76A80EF684 FOREIGN KEY (product_variant_id) REFERENCES product_variant (id)');
        $this->addSql('CREATE INDEX IDX_8E642C764584665A ON product_variant_product (product_id)');
        $this->addSql('CREATE INDEX IDX_8E642C76A80EF684 ON product_variant_product (product_variant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_variant_product DROP FOREIGN KEY FK_8E642C764584665A');
        $this->addSql('ALTER TABLE product_variant_product DROP FOREIGN KEY FK_8E642C76A80EF684');
        $this->addSql('DROP INDEX IDX_8E642C764584665A ON product_variant_product');
        $this->addSql('DROP INDEX IDX_8E642C76A80EF684 ON product_variant_product');
        $this->addSql('ALTER TABLE product_variant_product DROP product_id, DROP product_variant_id');
    }
}
