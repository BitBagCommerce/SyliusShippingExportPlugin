<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200528223136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bitbag_shipping_gateway (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, config JSON NOT NULL COMMENT \'(DC2Type:json_array)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_shipping_gateway_method (shipping_gateway_id INT NOT NULL, shipping_method_id INT NOT NULL, INDEX IDX_8606B9CBEF84DE5E (shipping_gateway_id), INDEX IDX_8606B9CB5F7D6850 (shipping_method_id), PRIMARY KEY(shipping_gateway_id, shipping_method_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bitbag_shipping_export (id INT AUTO_INCREMENT NOT NULL, shipment_id INT DEFAULT NULL, shipping_gateway_id INT DEFAULT NULL, exported_at DATETIME DEFAULT NULL, label_path VARCHAR(255) DEFAULT NULL, state VARCHAR(255) NOT NULL, external_id VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_20E62D9F7BE036FC (shipment_id), INDEX IDX_20E62D9FEF84DE5E (shipping_gateway_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bitbag_shipping_gateway_method ADD CONSTRAINT FK_8606B9CBEF84DE5E FOREIGN KEY (shipping_gateway_id) REFERENCES bitbag_shipping_gateway (id)');
        $this->addSql('ALTER TABLE bitbag_shipping_gateway_method ADD CONSTRAINT FK_8606B9CB5F7D6850 FOREIGN KEY (shipping_method_id) REFERENCES sylius_shipping_method (id)');
        $this->addSql('ALTER TABLE bitbag_shipping_export ADD CONSTRAINT FK_20E62D9F7BE036FC FOREIGN KEY (shipment_id) REFERENCES sylius_shipment (id)');
        $this->addSql('ALTER TABLE bitbag_shipping_export ADD CONSTRAINT FK_20E62D9FEF84DE5E FOREIGN KEY (shipping_gateway_id) REFERENCES bitbag_shipping_gateway (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bitbag_shipping_gateway_method DROP FOREIGN KEY FK_8606B9CBEF84DE5E');
        $this->addSql('ALTER TABLE bitbag_shipping_export DROP FOREIGN KEY FK_20E62D9FEF84DE5E');
        $this->addSql('DROP TABLE bitbag_shipping_gateway');
        $this->addSql('DROP TABLE bitbag_shipping_gateway_method');
        $this->addSql('DROP TABLE bitbag_shipping_export');
    }
}
