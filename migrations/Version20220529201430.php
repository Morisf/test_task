<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529201430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campers (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, power INT NOT NULL, is_manual_gear TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipments (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL, price INT NOT NULL, one_time_payment TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location_equipment (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, equipment_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_9DED03F564D218E (location_id), INDEX IDX_9DED03F5517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_equipment (id INT AUTO_INCREMENT NOT NULL, equipment_id INT DEFAULT NULL, orders_id INT NOT NULL, ordered_equipment_qty INT DEFAULT NULL, INDEX IDX_6FBFAE7B517FE9FE (equipment_id), INDEX IDX_6FBFAE7BCFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, start_location_id INT NOT NULL, end_location_id INT NOT NULL, camper_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, order_status VARCHAR(12) NOT NULL, INDEX IDX_E52FFDEE5C3A313A (start_location_id), INDEX IDX_E52FFDEEC43C7F1 (end_location_id), INDEX IDX_E52FFDEE7701A506 (camper_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stations (id INT AUTO_INCREMENT NOT NULL, country_code VARCHAR(2) NOT NULL, city VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location_equipment ADD CONSTRAINT FK_9DED03F564D218E FOREIGN KEY (location_id) REFERENCES stations (id)');
        $this->addSql('ALTER TABLE location_equipment ADD CONSTRAINT FK_9DED03F5517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipments (id)');
        $this->addSql('ALTER TABLE order_equipment ADD CONSTRAINT FK_6FBFAE7B517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipments (id)');
        $this->addSql('ALTER TABLE order_equipment ADD CONSTRAINT FK_6FBFAE7BCFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE5C3A313A FOREIGN KEY (start_location_id) REFERENCES stations (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEC43C7F1 FOREIGN KEY (end_location_id) REFERENCES stations (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE7701A506 FOREIGN KEY (camper_id) REFERENCES campers (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE7701A506');
        $this->addSql('ALTER TABLE location_equipment DROP FOREIGN KEY FK_9DED03F5517FE9FE');
        $this->addSql('ALTER TABLE order_equipment DROP FOREIGN KEY FK_6FBFAE7B517FE9FE');
        $this->addSql('ALTER TABLE order_equipment DROP FOREIGN KEY FK_6FBFAE7BCFFE9AD6');
        $this->addSql('ALTER TABLE location_equipment DROP FOREIGN KEY FK_9DED03F564D218E');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE5C3A313A');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEC43C7F1');
        $this->addSql('DROP TABLE campers');
        $this->addSql('DROP TABLE equipments');
        $this->addSql('DROP TABLE location_equipment');
        $this->addSql('DROP TABLE order_equipment');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE stations');
    }
}
