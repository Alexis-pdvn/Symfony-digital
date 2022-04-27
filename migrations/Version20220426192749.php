<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426192749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_variant_product DROP FOREIGN KEY FK_8E642C76A80EF684');
        $this->addSql('DROP TABLE product_variant');
        $this->addSql('DROP TABLE product_variant_product');
        $this->addSql('ALTER TABLE product_variant_price ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_variant_price ADD CONSTRAINT FK_90AFA1764584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_90AFA1764584665A ON product_variant_price (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_variant (id INT AUTO_INCREMENT NOT NULL, size VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_variant_product (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, product_variant_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_8E642C764584665A (product_id), INDEX IDX_8E642C76A80EF684 (product_variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_variant_product ADD CONSTRAINT FK_8E642C764584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_variant_product ADD CONSTRAINT FK_8E642C76A80EF684 FOREIGN KEY (product_variant_id) REFERENCES product_variant (id)');
        $this->addSql('ALTER TABLE product_variant_price DROP FOREIGN KEY FK_90AFA1764584665A');
        $this->addSql('DROP INDEX IDX_90AFA1764584665A ON product_variant_price');
        $this->addSql('ALTER TABLE product_variant_price DROP product_id');
    }
}
